import DangerButton from "@/Components/DangerButton";
import Modal from "@/Components/Modal";
import SecondaryButton from "@/Components/SecondaryButton";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-react";
import { useState } from "react";

const DeleteButton = ({url}) => {
    const [isModalOpen, setIsModalOpen] = useState(false);

    const closeModal = () => {
        setIsModalOpen(false);
    };

    const handleProceed = ()=> {
        Inertia.delete(url)
    }
    return (
        <>
            <button onClick={() => setIsModalOpen(true)}>
                <svg
                    height="18px"
                    version="1.1"
                    viewBox="0 0 14 18"
                    width="14px"
                >
                    <title />
                    <desc />
                    <defs />
                    <g
                        fill="none"
                        fillRule="evenodd"
                        id="Page-1"
                        stroke="none"
                        strokeWidth="1"
                    >
                        <g
                            fill="#e02424"
                            id="Core"
                            transform="translate(-299.000000, -129.000000)"
                        >
                            <g
                                id="delete"
                                transform="translate(299.000000, 129.000000)"
                            >
                                <path
                                    d="M1,16 C1,17.1 1.9,18 3,18 L11,18 C12.1,18 13,17.1 13,16 L13,4 L1,4 L1,16 L1,16 Z M14,1 L10.5,1 L9.5,0 L4.5,0 L3.5,1 L0,1 L0,3 L14,3 L14,1 L14,1 Z"
                                    id="Shape"
                                />
                            </g>
                        </g>
                    </g>
                </svg>
            </button>
            <Modal
                show={isModalOpen}
                closeable={true}
                onClose={closeModal}
                maxWidth="sm"
            >
                <p>Are you sure want to delete the item?</p>
                <div className="mt-6 flex justify-end">
                    <SecondaryButton onClick={closeModal}>
                        Cancel
                    </SecondaryButton>
                    <DangerButton onClick={handleProceed} className="ml-3">Yes</DangerButton>
                </div>
            </Modal>
        </>
    );
};

export default DeleteButton;
